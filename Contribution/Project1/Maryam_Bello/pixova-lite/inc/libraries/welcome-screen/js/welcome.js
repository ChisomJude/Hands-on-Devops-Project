var welcomeScreenFunctions = {
  /**
   * Import demo content
   */
   importDemoContent: function() {
    jQuery( '#add_default_sections' ).click( function() {
      var container = jQuery( this ).parents( '.action-required-box' ),
          checkboxes = container.find( ':checkbox' ),
          args = {
            action: [ 'Epsilon_Welcome_Screen', 'process_sample_content' ],
            nonce: welcomeScreen.ajax_nonce,
            args: []
          };

      jQuery.each( checkboxes, function( k, item ) {

        if ( jQuery( item ).prop( 'checked' ) ) {
          args.args.push( jQuery( item ).val() );
        }

      } );

      jQuery.ajax( {
        type: 'POST',
        data: { action: 'welcome_screen_ajax_callback', args: args },
        dataType: 'json',
        url: ajaxurl,
        success: function( json ) {
          location.reload();
        },
        /**
         * Throw errors
         *
         * @param jqXHR
         * @param textStatus
         * @param errorThrown
         */
        error: function( jqXHR, textStatus, errorThrown ) {
          console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
        }

      } );
    } );
  },

  /**
   * Automatically set front page
   */
  setFrontPage: function() {
    jQuery( '.epsilon-set-frontpage-button' ).click( function() {
      args = {
        action: [ 'Epsilon_Welcome_Screen', 'set_frontpage_to_static' ],
        nonce: welcomeScreen.ajax_nonce,
        args: []
      };

      jQuery.ajax( {
        type: 'POST',
        data: { action: 'welcome_screen_ajax_callback', args: args },
        dataType: 'json',
        url: ajaxurl,
        success: function( json ) {
          location.reload();
        },
        /**
         * Throw errors
         *
         * @param jqXHR
         * @param textStatus
         * @param errorThrown
         */
        error: function( jqXHR, textStatus, errorThrown ) {
          console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
        }

      } );
    } );
  },

  /**
   * Show hidden content
   */
  showHiddenContent: function() {
    jQuery( '.epsilon-hidden-content-toggler' ).on( 'click', function( e ) {
      e.preventDefault();
      jQuery( '#' + jQuery( this ).attr( 'data-toggle' ) ).slideToggle();
    } );
  },

  /**
   * Dismiss action through AJAX
   */
  dismissAction: function() {
    var args;

    jQuery( '.required-action-button' ).click( function() {
      args = {
        action: [ 'Epsilon_Welcome_Screen', 'handle_required_action' ],
        nonce: welcomeScreen.ajax_nonce,
        args: {
          'do': jQuery( this ).attr( 'data-action' ),
          'id': jQuery( this ).attr( 'id' )
        }
      };

      jQuery.ajax( {
        type: 'POST',
        data: { action: 'welcome_screen_ajax_callback', args: args },
        dataType: 'json',
        url: ajaxurl,
        success: function() {
          location.reload();
        },
        /**
         * Throw errors
         *
         * @param jqXHR
         * @param textStatus
         * @param errorThrown
         */
        error: function( jqXHR, textStatus, errorThrown ) {
          console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
        }

      } );
    } );
  },

  /**
   * Init Range sliders in backend
   *
   * @param context
   */
  rangeSliders: function( context ) {
    var sliders = context.find( '.slider-container' );

    jQuery.each( sliders, function() {
      var slider, input, inputId, id, instance, self;
      self = jQuery( this );
      slider = jQuery( this ).find( '.ss-slider' );
      input = jQuery( this ).find( 'input' );
      inputId = input.attr( 'id' );
      id = slider.attr( 'id' );
      instance = jQuery( '#' + id );

      instance.slider( {
        value: self.find( 'input' ).attr( 'value' ),
        range: 'min',
        min: parseFloat( instance.attr( 'data-attr-min' ) ),
        max: parseFloat( instance.attr( 'data-attr-max' ) ),
        step: parseFloat( instance.attr( 'data-attr-step' ) ),
        /**
         * Removed Change event because server was flooded with requests from
         * javascript, sending changesets on each increment.
         *
         * @param event
         * @param ui
         */
        slide: function( event, ui ) {
          self.find( 'input' ).attr( 'value', ui.value );
        },
        /**
         * Bind the change event to the "actual" stop
         * @param event
         * @param ui
         */
        stop: function( event, ui ) {
          jQuery( '#' + inputId ).trigger( 'change' );
        }
      } );

      jQuery( input ).on( 'focus', function() {
        jQuery( this ).blur();
      } );

      instance.attr( 'value', ( instance.slider( 'value' ) ) );
      instance.on( 'change', function() {
        jQuery( '#' + id ).slider( {
          value: jQuery( this ).val()
        } );
      } );
    } );
  },

  /**
   * Activate the plugin when the plugin has been installed
   */
  activatePlugin: function() {
    var activateButtonSlug = jQuery( 'a[data-slug]' );
    jQuery( activateButtonSlug ).on( 'click', function( e ) {
      var self = jQuery( this ),
          dataToSend = { plugin: self.attr( 'data-slug' ) };
      if ( self.hasClass( 'install-now' ) || self.hasClass( 'deactivate-now' ) ) {
        return;
      }
      e.preventDefault();

      jQuery.ajax( {
        beforeSend: function() {
          self.replaceWith( '<a class="button updating-message">' + welcomeScreen.activating_string + '...</a>' );
        },
        async: true,
        type: 'GET',
        dataType: 'html',
        url: self.attr( 'href' ),
        success: function( response ) {
          var actions;
          jQuery( '.updating-message' ).removeClass( 'updating-message' ).parents( '.action-required-box' ).slideUp( 200 ).remove();
          actions = jQuery( '#plugin-filter' ).find( '.action-required-box' );

          if ( ! actions.length ) {
            location.reload();
          }

          jQuery( document ).trigger( 'epsilon-plugin-activated', dataToSend );
        }
      } );
    } );

    jQuery( document ).on( 'wp-plugin-install-success', function( response, data ) {
      var activateButton = jQuery( 'a[data-slug="' + data.slug + '"]' ),
          dataToSend = { plugin: data.slug };
      if ( activateButton.length && ( jQuery( 'body' ).hasClass( welcomeScreen.body_class ) || jQuery( 'body' ).hasClass( 'wp-customizer' ) ) ) {

        jQuery.ajax( {
          beforeSend: function() {
            activateButton.replaceWith( '<a class="button updating-message">' + welcomeScreen.activating_string + '...</a>' );
          },
          async: true,
          type: 'GET',
          dataType: 'html',
          url: data.activateUrl,
          success: function( response ) {
            var actions;
            jQuery( '.updating-message' ).removeClass( 'updating-message' ).parents( '.action-required-box' ).slideUp( 200 ).remove();
            actions = jQuery( '#plugin-filter' ).find( '.action-required-box' );

            if ( ! actions.length ) {
              location.reload();
            }
            
            jQuery( document ).trigger( 'epsilon-plugin-activated', dataToSend );
          }
        } );
      }
    } );
  }

};

jQuery( document ).ready( function() {
  welcomeScreenFunctions.rangeSliders( jQuery( '#wpbody-content .widget-content' ) );
  welcomeScreenFunctions.dismissAction();
  welcomeScreenFunctions.setFrontPage();
  welcomeScreenFunctions.importDemoContent();
  welcomeScreenFunctions.showHiddenContent();
  welcomeScreenFunctions.activatePlugin();
} );

jQuery( document ).ajaxStop( function() {
  welcomeScreenFunctions.rangeSliders( jQuery( '#wpbody-content .widget-content' ) );
} );
