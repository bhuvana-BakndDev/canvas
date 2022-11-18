<?php

namespace App\Http\Controllers;

use App\Models\sketch;
use Illuminate\Http\Request;

use DB;


class sketchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sketch');
    }
    public function storecanvas(Request $request)    // save image
    {
    
        $list=DB::table('sketching')->insert(['value' => $request->dataURL,]);
        return $request->dataURL;
    }
 
     public function list()     // list drawing page
     {
            $list = DB::table('sketching')->get();
            return view('view' ,compact('list'));
        }
        
        public function drawPage(Request $request, $id){     //view drawing page
            $list=DB::table('sketching')->select('value')->where("id",$id)->first();
            return view('drawpage', compact('list'));
        }

        public function template()     //template list
         {
            $temp=DB::table('template')->get();
            return view('template', compact('temp'));
         }

         public function templateview(Request $request, $id){    //template view
            $gotid = $id;
            $tempview=DB::table('template')->select('template','id')->where("id",$id,)->first();
            // $htmltemplate = base64_decode($tempview->template);
            return view('templateview', compact('tempview','gotid'));
        }
        public function savetemplate(Request $request)      //save draw template
        {   
            $tempsave=DB::table('templatesave')->insert(['template' => $request->dataURL,'template_id' => $request->gotid,]);
            return $request->dataURL;
        }
        public function joins()   
        {
            $users = DB::table('template')
            ->join('templatesave', 'template.id', '=', 'templatesave.template_id')
            ->select('template.*', 'templatesave.*')
            ->get();
            //dd($users);
            return $users;
        }
        public function drawtemplate()     // drawing template list
        {
           $drawtemp=DB::table('templatesave')->get();
           return view('drawtemplate', compact('drawtemp'));
        }
        public function drawtemplateview(Request $request, $id){     //view drawing in template page
            $drawtempview=DB::table('templatesave')->select('template')->where("id",$id)->first();
            return view('drawtemplateview', compact('drawtempview'));
        }
        public function merging()
        {
            $temp1=DB::table('template')->first();
            $temp2=DB::table('templatesave')->where('id',10)->first();

           // $tempview1=DB::table('template')->select('template')->where("id" )->first();
            return view('merging', compact('temp1','temp2'));
            //return view('merging' );
        }

        public function sample()
        {
            return view('sample'); 
        }


       
}
