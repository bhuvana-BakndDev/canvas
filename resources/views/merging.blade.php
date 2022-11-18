<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div class="setbackground-<?php echo base64_decode($temp1->template);?>-" >
        <input type="hidden" class="setbackground-<?php echo $temp2->template; ?>-"/>

        <script>
        $(".setbackground").css("background-image");
        </script>

</body>
</html>