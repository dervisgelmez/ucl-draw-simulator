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

export enum FixtureStages {
  GROUP = 'group_stage',
  ROUND = 'round_of_16',
  QUARTER = 'quarter_final',
  SEMI = 'semi_final',
  FINAL = 'final'
}
