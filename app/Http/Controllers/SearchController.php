<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
class SearchController extends Controller
{
    public function index()
    {

        return view('post.index');
    }

function action(Request $request)
{
 if($request->ajax()) {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
            $data = DB::table('blogs')
            ->where('post_tittle', 'like', '%'.$query.'%')
            ->orderBy('id', 'desc')
            ->get();

        }
        else
        {
            $data = DB::table('blogs')
                ->orderBy('id', 'desc')
                ->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr>
                 <td>'.$row->post_photo.'</td>
                 <td>'.$row->post_tittle.'</td>
                 <td>'.$row->post_descripition.'</td>
                 <td>'.$row->published_at.'</td>
                </tr>
                ';
            }
        }
        else
        {
            $output = '
               <tr>
                <td align="center" colspan="5">No Data Found</td>
               </tr>
               ';
        }
        $data = array(
            'table_data'  => $output,
            'total_data'  => $total_row
        );

        echo json_encode($data);
        }
}
}
