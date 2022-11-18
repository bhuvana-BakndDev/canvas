<!DOCTYPE HTML>
<html>
    <head><meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<script>
    $(".canvas_clicked").click();
</script>

    <script type="text/javascript">
    var canvas, ctx, flag = false,
        prevX = 0,
        currX = 0,
        prevY = 0,
        currY = 0,
        dot_flag = false;

    var x = "black",      // default pencil color
        y = 2;

    function init() {
        canvas = document.getElementById('can');
        ctx = canvas.getContext("2d");
        // ctx.beginPath();
        // ctx.arc(95, 50, 40, 0, 2 * Math.PI);
        // ctx.stroke();
       // ctx.fillText("Hello World", 50, 50);
       //ctx.font = "30px Arial";
        // w = canvas.width;
        // h = canvas.height;

        canvas.addEventListener("mousemove", function (e) {
            findxy('move', e)
        }, false);
        canvas.addEventListener("mousedown", function (e) {
            
            findxy('down', e)
        }, false);
        canvas.addEventListener("mouseup", function (e) {
            
            findxy('up', e)
        }, false);
        canvas.addEventListener("mouseout", function (e) {
            findxy('out', e)
            
        }, false);

       

    }

    function color(obj) {
        switch (obj.id) {
            case "green":
                x = "green";
                break;
            case "blue":
                x = "blue";
                break;
            case "red":
                x = "red";
                break;
            case "yellow":
                x = "yellow";
                break;
            case "orange":
                x = "orange";
                break;
            case "black":
                x = "black";
                break;
            case "white":
                x = "white";
                break;
        }
        if (x == "white") y = 14;
        else y = 2;

    }
    
    function draw(y) {
        ctx.beginPath();
        ctx.moveTo(prevX, prevY);
        ctx.lineTo(currX, currY);
        ctx.lineCap = "round";
        ctx.strokeStyle = x;
        ctx.lineWidth = y;
        ctx.stroke();
        ctx.closePath();
    }

    function drawline(x1,y1,x2,y2) {
    ctx.strokeStyle = "green";
    ctx.lineJoin = "round";
    ctx.lineWidth = brushSize*2;

    ctx.beginPath();
    ctx.moveTo(x1,y1);
    ctx.lineTo(x2,y2);
    ctx.closePath();
    ctx.stroke();
    }

    function erase() {
        var m = confirm("Want to clear");
        if (m) {
            ctx.clearRect(0, 0, w, h);
            document.getElementById("canvasimg").style.display = "none";
        }
    }

    function save() {
        document.getElementById("canvasimg").style.border = "2px solid";
        var dataURL = canvas.toDataURL();
        //console.log(dataURL);
        // document.getElementById("canvasimg").src = dataURL;
        //  document.getElementById("canvasimg").style.display = "inline";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type: 'POST',
        url: "{{url('savetemplate')}}",
        data: {dataURL:dataURL}, 
        success: function(response) {
           // alert(response);
            console.log(response)
        },
        }); 
    }

    function findxy(res, e) {
        if (res == 'down') {
            prevX = currX;
            prevY = currY;
            currX = e.clientX - canvas.offsetLeft;
            currY = e.clientY - canvas.offsetTop;

            flag = true;
            dot_flag = true;
            if (dot_flag) {
                ctx.beginPath();
                ctx.fillStyle = x;
                ctx.fillRect(currX, currY, 2, 2);
                ctx.closePath();
                dot_flag = false;
            }
        }
        if (res == 'up' ) {
            var m = confirm("Wants to Finish");
            flag = false;
        }
        if ( res == "out") { 
            flag = false;
        }
        
        if (res == 'move') {
            if (flag) {
                prevX = currX;
                prevY = currY;
                currX = e.clientX - canvas.offsetLeft;
                currY = e.clientY - canvas.offsetTop;
                draw();
            }
        }
    }
    </script>
    <body onload="init()" style="background-image: src='c/WebProgram/Pictures/test1.png';">
        <div class="canvas_clicked" style="height: 100vh; overflow: hidden;">
            <canvas id="can"  style="position: absolute; top:0%;left:0%;border:2px solid;min-width:100% !important;min-height:100% !important;"></canvas>
            <div style="height: 100vh; overflow: auto;">
                <div style="top:12%;left:80%;"><b>Choose Color</b></div>
                <div style="top:15%;left:81%;width:10px;height:10px;background:green;" id="green" onclick="color(this)"></div>
                <div style="top:15%;left:83%;width:10px;height:10px;background:blue;" id="blue" onclick="color(this)"></div>
                <div style="top:15%;left:85%;width:10px;height:10px;background:red;" id="red" onclick="color(this)"></div>
                <div style="top:17%;left:81%;width:10px;height:10px;background:yellow;" id="yellow" onclick="color(this)"></div>
                <div style="top:17%;left:83%;width:10px;height:10px;background:orange;" id="orange" onclick="color(this)"></div>
                <div style="top:17%;left:85%;width:10px;height:10px;background:black;" id="black" onclick="color(this)"></div>
                <div style="top:20%;left:82%;"><b>Eraser</b></div>
                <div style="top:23%;left:83%;width:15px;height:15px;background:white;border:2px solid;" id="white" onclick="color(this)"></div>
                <img id="canvasimg" style="top:10%;left:52%;" value="<?php 
        echo base64_decode($tempview->template);
        ?>" style="display:none;">
                <input type="button" value="save" id="btn" size="30" class="btn btn-success" onclick="save()" style="top:5%;left:10%;">
                <input type="button" value="clear" id="clr" size="23" class="btn btn-danger" onclick="erase()" style="top:5%;left:15%;">
                <div>
                <p style="top:4%;left:30%;">Range:</p>
                <input type="range" min="1" max="100" value="20"  id="myRange" onchange="draw(this.value)" style="top:7%;left:27%;">
                <p style="top:6%;left:37%;">Value: <span id="demo"></span></p>
                </div>
                <button size="23" class="btn btn-warning"  style="top:5%;left:20%;"><a href="{{url('list')}}">view</a></button>
            </div>
        </div>
    </body>
    <script>
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;

        slider.oninput = function() {
        output.innerHTML = this.value;
        }
    </script>
    
   
</html>
