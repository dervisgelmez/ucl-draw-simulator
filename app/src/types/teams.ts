export interface Team {
  id: string;
  name: string;
  country: string;
  color: string;
  logo: string;
  stats?: TeamStats | null;
}

export interface TeamStats {
  attack: number;
  midfield: number;
  defense: number;
  speed: number;
  pass: number;
  shot: number;
  squad_depth: number;
  injury_risk: number;
  home_advantage: number;
  min_temp_performance: number;
  max_temp_performance: number;
  winner_mentality: number;
  loser_mentality: number;
  star_players_count: number;
  manager_influence: number;
}
