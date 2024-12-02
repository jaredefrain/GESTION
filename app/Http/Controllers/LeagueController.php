<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    public function standings()
    {
        $teams = DB::table('teams')->get();

        $standings = $teams->map(function ($team) {
            $games = DB::table('games')
                ->leftJoin('game_statistics as gs1', function ($join) use ($team) {
                    $join->on('games.id', '=', 'gs1.game_id')
                         ->where('gs1.team_id', '=', $team->id);
                })
                ->leftJoin('game_statistics as gs2', function ($join) use ($team) {
                    $join->on('games.id', '=', 'gs2.game_id')
                         ->where('gs2.team_id', '!=', $team->id);
                })
                ->select(
                    'games.id',
                    DB::raw('SUM(gs1.goals) as GF'),
                    DB::raw('SUM(gs2.goals) as GC'),
                    DB::raw('SUM(CASE WHEN gs1.goals > gs2.goals THEN 1 ELSE 0 END) as G'),
                    DB::raw('SUM(CASE WHEN gs1.goals < gs2.goals THEN 1 ELSE 0 END) as P'),
                    DB::raw('SUM(CASE WHEN gs1.goals = gs2.goals THEN 1 ELSE 0 END) as D'),
                    DB::raw('COUNT(DISTINCT games.id) as PJ'),
                    DB::raw('SUM(CASE WHEN gs1.goals > gs2.goals THEN 3 WHEN gs1.goals = gs2.goals THEN 1 ELSE 0 END) as PTS')
                )
                ->groupBy('games.id')
                ->get();

            $GF = $games->sum('GF');
            $GC = $games->sum('GC');
            $G = $games->sum('G');
            $P = $games->sum('P');
            $D = $games->sum('D');
            $PJ = $games->count();
            $PTS = $games->sum('PTS');
            $DG = $GF - $GC;
                

            // dd($games, $GF, $GC, $G, $P, $D, $PJ, $PTS, $DG);
            return (object) [
                'team_name' => $team->name,
                'PTS' => $PTS,
                'PJ' => $PJ,
                'G' => $G,
                'P' => $P,
                'D' => $D,
                'GF' => $GF,
                'GC' => $GC,
                'DG' => $DG,
            ];
        });

        $standings = $standings->sortByDesc('PTS')->sortByDesc('DG')->sortByDesc('GF');

        return view('league.standings', compact('standings'));
    }
}