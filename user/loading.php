<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Loading Page</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      background-color: #000;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #loadingPage {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at center, #111 0%, #000 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.5s ease;
    }

    .loader {
      border: 8px solid #1a1a1a;
      border-top: 8px solid red;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      animation: spin 1.2s linear infinite;
      box-shadow: 0 0 25px red;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .loading-text {
      color: red;
      font-size: 1.2rem;
      margin-top: 20px;
      text-align: center;
      text-shadow: 0 0 5px red;
      letter-spacing: 1px;
    }

    #mainContent {
      display: none;
      text-align: center;
      padding: 80px 20px;
    }

    #mainContent h1 {
      color: white;
      font-size: 2rem;
      text-shadow: 0 0 10px red;
    }

    @media (min-width: 600px) {
      .loader {
        width: 100px;
        height: 100px;
        border-width: 10px;
      }

      .loading-text {
        font-size: 1.5rem;
      }

      #mainContent h1 {
        font-size: 3rem;
      }
    }
  </style>
</head>
<body>

<!-- Loading Screen -->
<div id="loadingPage">
  <div class="loader"></div>
  <div class="loading-text">Loading, please wait...</div>
</div>

<div id="mainContent">
  <h1>Welcome to the Next Page</h1>
</div>

<script>
  setTimeout(() => {
    const loading = document.getElementById('loadingPage');
    loading.style.opacity = '0';
    setTimeout(() => {
      loading.style.display = 'none';
      document.getElementById('mainContent').style.display = 'block';
    }, 500);
  }, 2000);
</script>

</body>
</html>
