import type { Team } from '@/types/teams.ts'

export interface Fixture {
  id: string;
  name: string;
  week: number;
  stage: FixtureStage;
}

export interface FixtureStage {
  name: string;
  label: string;
  isKnockout: boolean;
  isFinal: boolean;
}

export interface FixtureGroupTeam {
  id: string;
  name: string;
  country: string;
  logo: string;
  color: string;
  attributes: {
    played: number;
    win: number;
    lose: number;
    draw: number;
    points: number;
    scored: number;
    conceded: number;
    average: number;
  }
}

export interface FixtureGroup {
  id: string;
  name: string;
  teams: FixtureGroupTeam[];
}

export interface FixtureMatch {
  id: string;
  stage: FixtureStage;
  week: number;
  date: string;
  completedAt: string;
  homeTeamScore: number | null;
  awayTeamScore: number | null;
  homeTeam: Team;
  awayTeam: Team;
  logs?: FixtureMatchLog[];
}

export interface FixtureMatchLog {
  minute: number
  team_id: string
  type: FixtureMatchLogType
}

export enum FixtureMatchLogType {
  GOAL = 'goal',
  PENALTY = 'penalty',
  PENALTY_GOAL = 'penalty_goal',
  PENALTY_MISS = 'penalty_miss',
  FREE_KICK = 'free_kick',
  FREE_KICK_GOAL = 'free_kick_goal',
  FREE_KICK_MISS = 'free_kick_miss',
  YELLOW_CARD = 'yellow_card',
  RED_CARD = 'red_card',
  CARD = 'card',
  INJURY = 'injury',
  PASS = 'pass',
}

export interface IFixtureStageComponentsProps {
  fixture: Fixture,
  clear?: boolean
}

export enum FixtureStages {
  GROUP = 'group_stage',
  ROUND = 'round_of_16',
  QUARTER = 'quarter_final',
  SEMI = 'semi_final',
  FINAL = 'final'
}
