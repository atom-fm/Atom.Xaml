<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/vs2015.min.css"
    integrity="sha256-9uLiFREx/Kkjh/rMpeUWdi+3+cr7Nr7GJukKXFp5qwU=" crossorigin="anonymous" />

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>hljs.initHighlightingOnLoad();</script>

    <script src="hotreload.js" guid="294f372e-874d-443e-82eb-99385889196e"></script>
    <style>
        body { padding: 20px}
    </style>
</head>
<body>
    <style>
        .error-message {
            position: absolute;
            z-index:1000;
            border:6px solid purple;
            padding:5px;
            background:white;
            right:10px;
            top:10px;
            left:10px;
        }
    </style>
    <div class="error-message" id="errorMessage" style="display:none">
        <b>Error:</b><br>
        <div id="errorMessageContent">
        </div>
    </div>
    <?=$content?>
</body>
</html>
