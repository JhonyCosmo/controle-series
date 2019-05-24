<?php


namespace App\Servicos;


use App\Serie;
use App\Temporada;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    /**
     * Cria a serie no banco de dados
     * @param string $nomeSerie
     * @param int $qtdTemporada
     * @param int $epPorTemporada
     * @return null
     */
    public function criarSerie(
        string $nomeSerie ,
        int $qtdTemporada,
        int $epPorTemporada):Serie
    {
        $serie=null;
        //Iniciando uma transacao
        DB::beginTransaction();
        //Automaticamente sera realizado um bind com o objeto serie
        //$serie = Serie::create($request->all ());
        //Buscando o campo nome na request e atribuindo ao objeto serie
        $serie=Serie::create(['nome'=>$nomeSerie]);
        //Adicionanando temporadas
        $this->criarTemporadas($serie,$qtdTemporada,$epPorTemporada);
        //Comitando a transação
        DB::commit();
        return $serie;
    }

    /**
     * Cria as temporadas na serie passada por parametro
     * @param Serie $serie
     * @param int $qtdTemporada
     * @param $epPorTemporada
     */
    private function criarTemporadas(Serie $serie,int $qtdTemporada,$epPorTemporada){

        for ($i=1;$i<=$qtdTemporada;$i++){
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            //Adicionando episodios
            $this->criarEpisodios($temporada,$epPorTemporada);
        }
    }

    /**
     * Adiciona os episodios
     * @param Temporada $temporada
     * @param int $epPorTemporada
     */
    private function criarEpisodios(Temporada $temporada,int $epPorTemporada){
        //Adicionando episodios
        for($j=1;$j<=$epPorTemporada;$j++){
            $temporada->episodios()->create(['numero'=>$j]);
        }
    }
}
