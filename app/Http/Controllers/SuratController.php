<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\srt;
use DataTables;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $srts = srt::get();
        if($request->ajax()){
            $allData = DataTables::of($srts)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                $row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm
                editSrt">Edit</a>';

                $btn.= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
                $row->id.'" data-original-title="Delete" class="delete btn btn-danger btn-sm
                deleteSrt">Delete</a>';
                return $btn;
            })

            ->rawColumns(['action'])
            ->make(true);
            return $allData;
        }
        return view('srts', compact('srts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        srt::updateOrCreate(
        ['id'=>$request->surat_id],
        ['nama'=>$request->nama,
        'tanggal'=>$request->tanggal
        ]
        );
        return response()->json(['success'=>'Surat Ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $srts = srt::find($id);
        return response()->json($srts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        srt::find($id)->delete();
        return response()->json(['success'=>'Data berhasil di hapus']);
    }
}
