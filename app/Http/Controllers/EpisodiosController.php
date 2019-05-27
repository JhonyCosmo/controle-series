<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Temporada;
use function foo\func;
use Illuminate\Http\Request;
use function PHPSTORM_META\expectedArguments;

class EpisodiosController extends Controller
{
    public function index(Temporada $temporada,Request $request)
    {
        return view('episodios.index',[
            'episodios'=>$temporada->episodios,
            'temporadaId'=>$temporada->id,
            'mensagem'=>$request->session()->get('mensagem')
        ]);
    }

    public function assistir(Temporada $temporada,Request $request)
    {
        $episodiosAssistidos=$request->episodios;
        $temporada->episodios->each(function(Episodio $episodio) use ($episodiosAssistidos){
            if(!$episodiosAssistidos==null){
                $episodio->assistido=in_array(
                    $episodio->id,
                    $episodiosAssistidos
                );
            }else{
                $episodio->assistido=false;
            }
        });
        $temporada->push();
        $request->session()->flash('mensagem','Episodios marcados com sucesso');
        return redirect()->back();
    }
}
