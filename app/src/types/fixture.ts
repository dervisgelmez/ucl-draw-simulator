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
