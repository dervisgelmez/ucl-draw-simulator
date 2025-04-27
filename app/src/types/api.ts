export enum ApiStates {
  IDLE = 'idle',
  SUCCESS = 'success',
  ERROR = 'error',
  LOADING = 'loading',
  EMPTY = 'empty'
}

export interface ApiResponse {
  success: boolean;
  message: string | null;
  data: never;
}
