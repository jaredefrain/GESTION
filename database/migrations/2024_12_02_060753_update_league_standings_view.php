<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS league_standings");

        DB::statement("
            CREATE VIEW league_standings AS
            SELECT
                t.id AS team_id,
                t.name AS team_name,
                COALESCE(SUM(gs.goals), 0) AS GF,
                COALESCE(SUM(opponent_goals.goals), 0) AS GC,
                SUM(CASE WHEN gs.goals > opponent_goals.goals THEN 1 ELSE 0 END) AS G,
                SUM(CASE WHEN gs.goals < opponent_goals.goals THEN 1 ELSE 0 END) AS P,
                SUM(CASE WHEN gs.goals = opponent_goals.goals THEN 1 ELSE 0 END) AS D,
                COUNT(DISTINCT g.id) AS PJ,
                SUM(CASE WHEN gs.goals > opponent_goals.goals THEN 3
                         WHEN gs.goals = opponent_goals.goals THEN 1 ELSE 0 END) AS PTS,
                (COALESCE(SUM(gs.goals), 0) - COALESCE(SUM(opponent_goals.goals), 0)) AS DG
            FROM teams t
            LEFT JOIN games g ON t.id = g.team1_id OR t.id = g.team2_id
            LEFT JOIN (
                SELECT game_id, team_id, SUM(goals) AS goals
                FROM game_statistics
                GROUP BY game_id, team_id
            ) gs ON g.id = gs.game_id AND t.id = gs.team_id
            LEFT JOIN (
                SELECT game_id, team_id, SUM(goals) AS goals
                FROM game_statistics
                GROUP BY game_id, team_id
            ) opponent_goals ON g.id = opponent_goals.game_id AND t.id != opponent_goals.team_id
            GROUP BY t.id, t.name
            ORDER BY PTS DESC, DG DESC, GF DESC;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS league_standings");
    }
};
