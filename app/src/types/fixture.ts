import type { Team } from '@/types/teams.ts'

export interface Fixture {
  id: string;
  name: string;
  stage: FixtureStage;
}

export interface FixtureStage {
  name: string;
  label: string;
  isKnockout: boolean;
  isFinal: boolean;
}

export interface FixtureGroup {
  id: string;
  name: string;
  teams: Team[];
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
  fixture: Fixture
}

export enum FixtureStages {
  GROUP = 'group_stage',
  ROUND = 'round_of_16',
  QUARTER = 'quarter_final',
  SEMI = 'semi_final',
  FINAL = 'final'
}
