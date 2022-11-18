<!DOCTYPE html>
<html lang="en">
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>
<table style="width:100%">
<h1>DRAW TEMPLATES:</h1>

    <tr>
    <th>ID</th>  
    <th>DRAWING IN  TEMPLATES</th>
    <th>ACTION</th>  
</tr>
<?php $i=0; ?> 
@foreach ($drawtemp as $value)
<?php $i++ ?>
    <tr>
        <td>{{ $i }}</td>
    <td>  DRAW Template.{{ $value->id}}</td>
    <td> <a href="{{url('drawtemplateview', ['id' => $value->id ])}}" >view</a></td>
    
   </tr>
    @endforeach
   
</table>
</body>


</html>