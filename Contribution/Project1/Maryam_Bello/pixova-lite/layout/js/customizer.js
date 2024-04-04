( function( $ ) {// jscs:ignore validateLineBreaks

    /* Multi-level panels in customizer */

    var api = wp.customize;

    // Extend Panel
    var _panelEmbed = wp.customize.Panel.prototype.embed;
    var _panelIsContextuallyActive = wp.customize.Panel.prototype.isContextuallyActive;
    var _panelAttachEvents = wp.customize.Panel.prototype.attachEvents;

    var panels = [ 'pixova_lite_panel_intro', 'pixova_lite_panel_about', 'pixova_lite_panel_works', 'pixova_lite_panel_testimonials', 'pixova_lite_panel_news', 'pixova_lite_panel_team', 'pixova_lite_panel_contact' ];

    api.bind( 'pane-contents-reflowed', function() {

        // Reflow panels
        var panels = [];

        api.panel.each( function( panel ) {

            if (
                'pixova_panel' !== panel.params.type ||
                'undefined' === typeof panel.params.panel
            ) {

                return;

            }

            panels.push( panel );

        });

        panels.sort( api.utils.prioritySort ).reverse();

        $.each( panels, function( i, panel ) {

            var parentContainer = $( '#sub-accordion-panel-' + panel.params.panel );

            parentContainer.children( '.panel-meta' ).after( panel.headContainer );

        });

    });

    wp.customize.Panel = wp.customize.Panel.extend({
        attachEvents: function() {
            var panel = this;
            if (
                'pixova_panel' !== this.params.type ||
                'undefined' === typeof this.params.panel
            ) {

                _panelAttachEvents.call( this );

                return;

            }

            _panelAttachEvents.call( this );

            panel.expanded.bind( function( expanded ) {

                var parent = api.panel( panel.params.panel );

                if ( expanded ) {

                    parent.contentContainer.addClass( 'current-panel-parent' );

                } else {

                    parent.contentContainer.removeClass( 'current-panel-parent' );

                }

            });

            panel.container.find( '.customize-panel-back' )
                .off( 'click keydown' )
                .on( 'click keydown', function( event ) {

                    if ( api.utils.isKeydownButNotEnterEvent( event ) ) {

                        return;

                    }

                    event.preventDefault(); // Keep this AFTER the key filter above

                    if ( panel.expanded() ) {

                        api.panel( panel.params.panel ).expand();

                    }

                });

        },
        embed: function() {
            var panel = this;
            var parentContainer = $( '#sub-accordion-panel-' + this.params.panel );

            if (
                'pixova_panel' !== this.params.type ||
                'undefined' === typeof this.params.panel
            ) {

                _panelEmbed.call( this );

                return;

            }

            _panelEmbed.call( this );

            parentContainer.append( panel.headContainer );

        },
        isContextuallyActive: function() {
            var panel = this;
            var children = this._children( 'panel', 'section' );
            var activeCount = 0;

            if (
                'pixova_panel' !== this.params.type
            ) {

                return _panelIsContextuallyActive.call( this );

            }

            api.panel.each( function( child ) {

                if ( ! child.params.panel ) {

                    return;

                }

                if ( child.params.panel !== panel.id ) {

                    return;

                }

                children.push( child );

            });

            children.sort( api.utils.prioritySort );

            _( children ).each( function( child ) {

                if ( child.active() && child.isContextuallyActive() ) {

                    activeCount += 1;

                }

            });

            return ( 0 !== activeCount );

        }

    });

    // Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
    jQuery.each( panels, function( index, panel ) {
        api.panel( panel, function( panel ) {
            panel.expanded.bind( function( isExpanding ) {

                // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
                api.previewer.send( 'section-highlight', { expanded: isExpanding, section: panel.id });
            } );
        } );
    });

    function pixovaSectionsOrder( container ) {
        var sections = $( '#sub-accordion-panel-pixova_lite_frontpage_sections' ).sortable( 'toArray' );
        var sOrdered = [];
        $.each( sections, function( index, sID ) {
            sID = sID.replace( 'accordion-panel-', '' );
            sOrdered.push( sID );
        });

        $.ajax({
            url: PixovaCustomizer.ajax_url,
            type: 'post',
            dataType: 'html',
            data: {
                'action': 'pixova_order_sections',
                'sections': sOrdered
            }
        })
        .done( function( data ) {
            wp.customize.previewer.refresh();
        });

    }

    wp.customize.bind( 'ready', function() {

        $( '#sub-accordion-panel-pixova_lite_frontpage_sections' ).sortable({
            helper: 'clone',
            items: '> li.control-section',
            cancel: 'li.ui-sortable-handle.open',
            delay: 150,
            update: function( event, ui ) {

                pixovaSectionsOrder( $( 'sub-accordion-panel-pixova_lite_frontpage_sections' ) );

            }
        });
    });

})( jQuery );
