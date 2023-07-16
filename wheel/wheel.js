var content = document.getElementById("wheel");
var spin = document.getElementById("button");
var historybtn = document.getElementById("button2")
const animation = document.querySelector(".reducted");
var i,x = 0;
const array = [i];
var tick = 0;
var cycle = 6*360; //6 spins
var prize = 0;
var bet,bet2 = 10; //CHANGE THIS FOR BET AMOUNT & ON LINE 28
var coins = 50; //CHANGE THIS FOR WALLET AMMOUNT

//makes the wallet amount appear on the div
document.getElementById("wallet").innerHTML = "💰: " + coins+" €";

spin.onclick = function() { //everything under here initiates when you click SPIN

  // injects button styles to appear pressed in
  spin.style.backgroundColor = "#476eb4";
  spin.style.opacity = "0.6";
  spin.style.boxShadow = "0 3px 1.5px #666";
  spin.style.transform = "translate(0%, 14%)";
  spin.style.pointerEvents = "none";

  document.getElementById("text").innerHTML = ""; //removes won amount on SLOT window after click

  //updates the total wallet amount
  bet=10;
  coins=coins-bet;
  document.getElementById("wallet").innerHTML = "💰: "+coins+" €";

  //makes the deduct amount visible & initiates the animation
  animation.style.visibility="visible";
  animation.innerHTML = "-"+bet;
  animation.classList.add('animate__animated', 'animate__fadeOutUp');

  //random int injected into the rotation for random spins
  tick++;
  cycles = Math.ceil(Math.random() * 360) + (cycle*tick); //random spin plus normal spins
  content.style.transform = "rotate(" + cycles + "deg)"; //rotate the wheel
  prize = Math.ceil((cycles % 360) / 45); //divides the wheel to determine prize | gives a value 1-8
};

content.ontransitionend = function(){ //everything under here initiates when the wheel stops spinning

  //prize value determines the won amount & calculates the wallet amount
  //prize value 1-8 are the wheel slices where 1 is red, 2 is purple and so on..
  switch (prize){
    case 1:
      bet-=bet;
      document.getElementById("text").innerHTML = bet + " €";
      coin=coins-bet;
      break;
    case 2:
      bet=bet*1.2;
      document.getElementById("text").innerHTML = bet + " €";
      coins=coins+bet;
      break;
    case 3:
      bet-=bet;
      document.getElementById("text").innerHTML = bet + " €";
      coin=coins-bet;
      break;
    case 4:
      bet=bet*1.2;
      document.getElementById("text").innerHTML = bet + " €";
      coins=coins+bet;
      break;
    case 5:
      bet=bet*5;
      document.getElementById("text").innerHTML = bet + " €";
      coins=coins+bet;
      break;
    case 6:
      bet=bet*1.2;
      document.getElementById("text").innerHTML = bet + " €";
      coins=coins+bet;
      break;
    case 7:
      bet-=bet;
      document.getElementById("text").innerHTML = bet + " €";
      coin=coins-bet;
      break;
    case 8:
      bet=bet*2;
      document.getElementById("text").innerHTML = bet + " €";
      coins=coins+bet;
      break;}

  //updates the wallet from the calculated amount
  document.getElementById("wallet").innerHTML = "💰: "+coins+" €";

  //deduction animation dissapears
  animation.classList.remove('animate__animated', 'animate__fadeOutUp');
  animation.style.visibility="hidden";

  //injects button styles in css to make button appear available again
  spin.style.boxShadow = "0 5px 1.5px #999";
  spin.style.opacity = "1";
  spin.style.backgroundColor = "rgba(0, 0, 0, 0.4)";
  spin.style.transform = "translate(0%, 0%)";
  spin.style.pointerEvents = "auto";

  //array to save history prize
  for (var i = 0; x < 10; x++){
    if (bet==0){
      break;
    }
    array.push(bet+" €");
    i++;
    break;
  }

  //injects the array into html
  document.getElementById("historytext").innerHTML=array;
  document.getElementById("historytext").textContent=array.join("\n");

  //If there are not enough money on the wallet, it disables the button
  if(coins<bet2){
  spin.style.pointerEvents = "none";
  spin.style.opacity = "0.4";
  }
};

//button to toggle history window
function toggle(){ //initiates when you click the history btn
  var x = document.getElementById("history");
  x.classList.toggle("hide");
};