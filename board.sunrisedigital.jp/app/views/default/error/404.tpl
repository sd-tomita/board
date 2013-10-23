<head>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
  <style>
    .sdx_error{
      font-size: 12px;
      margin: 0;
      padding: 0;
      font-weight: bold;
      list-style: none;
      color: #b94a48;
    }
    .sdx_error > li:before{
      content: "\f14a";
      font-family: FontAwesome;
    }
  </style>
</head>
<body <!--style="background-color: #ccff99"-->>
<h2 <!--style="background-color:white; color:blue"-->>404Error</h2>
<ul <!--style="border: solid"-->>
<li>{$message}</li>
<li>Module:{$module}</li>
<li>Controller:{$controller}</li>
<li>Action:{$action}</li>
</ul>
</body>