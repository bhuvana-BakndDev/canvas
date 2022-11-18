<!DOCTYPE html>
<html lang="en">
<head><meta name="csrf-token" content="{{ csrf_token() }}" /></head>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>
<table style="width:100%">
<h1> List Page:</h1>

    <tr>
    <th>ID</th>  
    <th>DRAWING NAME</th>
    <th>ACTION</th>  
</tr>
<?php $i=0; ?> 
@foreach ($list as $value)
<?php $i++ ?>
    <tr>
        <td>{{ $i }}</td>
    <td> Drawing.{{ $value->id}}</td>
    <td> <a href="{{url('drawpage', ['id' => $value->id ])}}" class="viewsketch" >view</a></td>
    
   </tr>
    @endforeach
   
</table>
</body>


</html>