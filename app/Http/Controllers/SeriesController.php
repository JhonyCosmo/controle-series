<?php


namespace App\Http\Controllers;

use App\Episodio;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Servicos\CriadorDeSerie;
use App\Servicos\RemovedorSerie;
use App\Temporada;
use function Faker\Provider\pt_BR\check_digit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SeriesController extends Controller
{
    public function index(Request $request)
    {
       $series=Serie::query()->orderBy('nome')->get();
       $mensagem= $request->session()->get('mensagem');
       return view('series.index', compact('series','mensagem'));
    }

    public function create(Request $request)
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request,CriadorDeSerie $criadorDeSerie)
    {
        $serie=$criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada);

        $request->session()
            ->flash(
            'mensagem',
            "Série {$serie->id} criada com sucesso {$serie->nome} e suas temporadas e episodios foram criadas");

        return redirect()->route('listar_series');
    }

    public function  destroy(Request $request,RemovedorSerie $removedor):string{
        //Removendo manualmente os registros viculados a serie
        //Retornando a serie
        $nomeSerie=$removedor->removerSerie($request->id);
        $request->session()
            ->flash(
                'mensagem',
                "Série {$request->id} - {$nomeSerie} removida com sucesso ");
        return redirect()->route('listar_series');
    }

    public function editaNome(int $serieId,Request $request)
    {
        $novoNome=$request->nome;
        $serie=Serie::find($serieId);
        $serie->nome=$novoNome;
        $serie->save();
    }
}
