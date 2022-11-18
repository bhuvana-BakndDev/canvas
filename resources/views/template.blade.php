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
<h1>TEMPLATES:</h1>

    <tr>
    <th>ID</th>  
    <th>TEMPLATES</th>
    <th>ACTION</th>  
</tr>
<?php $i=0; ?> 
@foreach ($temp as $value)
<?php $i++ ?>
    <tr>
        <td>{{ $i }}</td>
    <td> Template.{{ $value->id}}</td>
    <td> <a href="{{url('templateview', ['id' => $value->id ])}}" >view</a></td>
    
   </tr>
    @endforeach
   
</table>
</body>


</html>