<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@600&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <title>Spinner</title>
</head>
<body>
  <img id="hand" src="mec.png">
  <img id="wheel" src="https://i.imgur.com/MRyOcpy.png">
  <div id="button">SPIN</div>
  <div id="button2"onclick="toggle()">HISTORY</div>

  <div id="history" class="hide"> <!--History Window-->
    <div id="historytext"></div>  <!--The text inside that window injected by js-->
  </div>

  <div id="slot">YOU WON: <p id="text"></p></div> <!--Slot Prize Window-->

  <div id="wallet"></div>
  <div class="reducted"></div> <!--Animation-->

  <ul class="info">
    <li><img class="pic" src="https://i.imgur.com/UfHEbkR.png"> x0</li>
    <li><img class="pic1" src="https://i.imgur.com/ka2cDlH.png"> x1.2</li>
    <li><img class="pic2" src="https://i.imgur.com/7LnDOwj.png"> x2</li>
    <li><img class="pic3" src="https://i.imgur.com/EOwnTfP.png">x5</li>
  </ul>

  <script src="wheel.js"></script>
</body>