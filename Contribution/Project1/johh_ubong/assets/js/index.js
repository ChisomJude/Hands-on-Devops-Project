

const counter = document.querySelector('.p_view');



async function updateCounter() {
    const response = await fetch("https://ybn84o0041.execute-api.us-east-1.amazonaws.com/live/views");
    const data = await response.json();
    
    counter.textContent = `Page Views: ${data}`
    console.log(counter.textContent);

}

updateCounter();


  