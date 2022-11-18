<!DOCTYPE HTML>
<html>
    <head><meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<style>#iframe {
  position: absolute;
  left: 250px;
  top: 250px;
}

#canvas {
  border:2px solid #000000;
  position: absolute;
  top: 50px;
  left: 50px;
}</style>
<!-- <input type="hidden" class="sourcecode" value=<?php echo base64_decode($tempview->template);?>/> -->


<script>
    $(document).ready(function() {
  initialize();
});

// works out the X, Y position of the click inside the canvas from the X, Y position on the page

function getPosition(mouseEvent, sigCanvas) {
    var rect = sigCanvas.getBoundingClientRect();
    return {
      X: mouseEvent.clientX - rect.left,
      Y: mouseEvent.clientY - rect.top
    };
}

/*function getPosition(mouseEvent, sigCanvas) {
  var x, y;
  if (mouseEvent.pageX != undefined && mouseEvent.pageY != undefined) {
    x = mouseEvent.pageX;
    y = mouseEvent.pageY;

  } else {
    x = mouseEvent.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
    y = mouseEvent.clientY + document.body.scrollTop + document.documentElement.scrollTop;
  }

  return {
    X: x - sigCanvas.offsetLeft,
    Y: y - sigCanvas.offsetTop
  };
}*/

function initialize() {
  // get references to the canvas element as well as the 2D drawing context
  var sigCanvas = document.getElementById("canvas");
  var context = sigCanvas.getContext("2d");
  context.strokeStyle = "#000";
  context.lineJoin = "round";
  context.lineWidth = 5;

  // Add background image to canvas - remove for blank white canvas
  var background = new Image();
  background.src = "https://3.bp.blogspot.com/_jFM-Fd8NDFE/TLhmRK1h8AI/AAAAAAAAKcU/NKNPe051PbA/s1600/OldCanvas-5.jpg";
  // Make sure the image is loaded first otherwise nothing will draw.
  background.onload = function() {
    context.drawImage(background, 0, 0);
  }

  // This will be defined on a TOUCH device such as iPad or Android, etc.
  var is_touch_device = 'ontouchstart' in document.documentElement;

  if (is_touch_device) {
    // create a drawer which tracks touch movements
    var drawer = {
      isDrawing: false,
      touchstart: function(coors) {
        context.beginPath();
        context.moveTo(coors.x, coors.y);
        this.isDrawing = true;
      },
      touchmove: function(coors) {
        if (this.isDrawing) {
          context.lineTo(coors.x, coors.y);
          context.stroke();
        }
      },
      touchend: function(coors) {
        if (this.isDrawing) {
          this.touchmove(coors);
          this.isDrawing = false;
        }
      }
    };

    // create a function to pass touch events and coordinates to drawer
    function draw(event) {

      // get the touch coordinates.  Using the first touch in case of multi-touch
      var coors = {
        x: event.targetTouches[0].pageX,
        y: event.targetTouches[0].pageY
      };

      // Now we need to get the offset of the canvas location
      var obj = sigCanvas;

      if (obj.offsetParent) {
        // Every time we find a new object, we add its offsetLeft and offsetTop to curleft and curtop.
        do {
          coors.x -= obj.offsetLeft;
          coors.y -= obj.offsetTop;
        }
        // The while loop can be "while (obj = obj.offsetParent)" only, which does return null
        // when null is passed back, but that creates a warning in some editors (i.e. VS2010).
        while ((obj = obj.offsetParent) != null);
      }

      // pass the coordinates to the appropriate handler
      drawer[event.type](coors);
    }

    // attach the touchstart, touchmove, touchend event listeners.
    sigCanvas.addEventListener('touchstart', draw, false);
    sigCanvas.addEventListener('touchmove', draw, false);
    sigCanvas.addEventListener('touchend', draw, false);

    // prevent elastic scrolling
    sigCanvas.addEventListener('touchmove', function(event) {
      event.preventDefault();
    }, false);
  } else {

    // start drawing when the mousedown event fires, and attach handlers to
    // draw a line to wherever the mouse moves to
    $("#canvas").mousedown(function(mouseEvent) {
      var position = getPosition(mouseEvent, sigCanvas);
      context.moveTo(position.X, position.Y);
      context.beginPath();

      // attach event handlers
      $(this).mousemove(function(mouseEvent) {
        drawLine(mouseEvent, sigCanvas, context);
      }).mouseup(function(mouseEvent) {
        finishDrawing(mouseEvent, sigCanvas, context);
      }).mouseout(function(mouseEvent) {
        finishDrawing(mouseEvent, sigCanvas, context);
      });
    });

  }
}

// draws a line to the x and y coordinates of the mouse event inside
// the specified element using the specified context
function drawLine(mouseEvent, sigCanvas, context) {

  var position = getPosition(mouseEvent, sigCanvas);

  context.lineTo(position.X, position.Y);
  context.stroke();
}

// draws a line from the last coordiantes in the path to the finishing
// coordinates and unbind any event handlers which need to be preceded
// by the mouse down event
function finishDrawing(mouseEvent, sigCanvas, context) {
  // draw the line to the finishing coordinates
  drawLine(mouseEvent, sigCanvas, context);

  context.closePath();

  // unbind any events which could draw
  $(sigCanvas).unbind("mousemove")
    .unbind("mouseup")
    .unbind("mouseout");
}

// Clear the canvas context using the canvas width and height
function clearCanvas(canvas, ctx) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}
</script>

    <!-- <script type="text/javascript">
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
        w = canvas.width;
        h = canvas.height;
        alert($('.sourcecode').val());
        $('#can').append($('.sourcecode').val());

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
    </script> -->
    <body onload="init()" style="background-image: src='c/WebProgram/Pictures/test1.png';">
        <!-- <canvas id="can" width="1400" height="1000" style="position:absolute;top:10%;left:1%;border:2px solid;"></canvas>
        <div style="position:absolute;top:12%;left:80%;"><b>Choose Color</b></div>
        <div style="position:absolute;top:15%;left:81%;width:10px;height:10px;background:green;" id="green" onclick="color(this)"></div>
        <div style="position:absolute;top:15%;left:83%;width:10px;height:10px;background:blue;" id="blue" onclick="color(this)"></div>
        <div style="position:absolute;top:15%;left:85%;width:10px;height:10px;background:red;" id="red" onclick="color(this)"></div>
        <div style="position:absolute;top:17%;left:81%;width:10px;height:10px;background:yellow;" id="yellow" onclick="color(this)"></div>
        <div style="position:absolute;top:17%;left:83%;width:10px;height:10px;background:orange;" id="orange" onclick="color(this)"></div>
        <div style="position:absolute;top:17%;left:85%;width:10px;height:10px;background:black;" id="black" onclick="color(this)"></div>
        <div style="position:absolute;top:20%;left:82%;"><b>Eraser</b></div>
        <div style="position:absolute;top:23%;left:83%;width:15px;height:15px;background:white;border:2px solid;" id="white" onclick="color(this)"></div>
        <img id="canvasimg" style="position:absolute;top:10%;left:52%;" style="display:none;">
        <input type="button" value="save" id="btn" size="30" class="btn btn-success" onclick="save()" style="position:absolute;top:5%;left:10%;">
        <input type="button" value="clear" id="clr" size="23" class="btn btn-danger" onclick="erase()" style="position:absolute;top:5%;left:15%;">
        <div>
           <p style="position:absolute;top:4%;left:30%;">Range:</p>
           <input type="range" min="1" max="100" value="20"  id="myRange" onchange="draw(this.value)" style="position:absolute;top:7%;left:27%;">
           <p style="position:absolute;top:6%;left:37%;">Value: <span id="demo"></span></p>
        </div>
        <button size="23" class="btn btn-warning"  style="position:absolute;top:5%;left:20%;"><a href="{{url('list')}}">view</a></button> -->

        <div id="iframe">
  <canvas id="canvas" width="500px" height="500px">

<iframe src="<?php echo base64_decode($tempview->template);?>" frameborder="0"></iframe>
  
  </canvas>
  <input type="submit" value="Clear Canvas" id="clearbutton" onclick="clearCanvas(canvas,ctx);">
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
