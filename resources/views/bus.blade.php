<!DOCTYPE html>
<html>
<head>
    <title>Plano de las ruedas de un autobús</title>
    <style>
        .bus {
            width: 500px;
            height: 1000px;
            background-color: white;
            position: relative;
            box-sizing: border-box;
            border: 2px solid black;
        }
        .wheel {
            width: 100px;
            height: 100px;
            background-color: black;
            border-radius: 50%;
            position: absolute;
            top: 450px;
            left: 50px;
            box-sizing: border-box;
            border: 2px solid white;
        }
        .front-wheel {
            left: 50px;
        }
        .back-wheel {
            left: 350px;
        }
        .middle-wheel {
            left: 200px;
        }
        .wheel-label {
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            transform: rotate(90deg);
            transform-origin: bottom right;
            top: 300px;
            left: 60px;
            width: 100px;
            text-align: center;
        }
        .front-wheel-label {
            left: 60px;
        }
        .back-wheel-label {
            left: 360px;
        }
        .middle-wheel-label {
            left: 210px;
        }
    </style>
</head>
<body>
<div class="bus">
    <div class="wheel front-wheel"></div>
    <div class="wheel back-wheel"></div>
    <div class="wheel middle-wheel"></div>

</div>
</body>
</html>
