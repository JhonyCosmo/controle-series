<?php


namespace App\Servicos;


use App\{Episodio,Serie,Temporada};
use Illuminate\Support\Facades\DB;

class RemovedorSerie
{
    public function removerSerie(int $serieId)
    {
        $nomeSerie="";

        DB::transaction(function () use(&$nomeSerie,$serieId){
            $serie=Serie::find($serieId);
            $nomeSerie=$serie->nome;
            $this->removerTemporadas($serie);
            $serie->delete();
        });
        return $nomeSerie;
    }
    /**
     * @param $serie
     */
    private function removerTemporadas($serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            //Removendo temporada
            $temporada->delete();
        });

    }
    /**
     * @param Temporada $temporada
     */
    private function removerEpisodios(Temporada $temporada): void
    {
        //Retornando os episodios da temporada
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }
}
