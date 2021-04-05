import { MoviesDurationPipe } from './movies-duration.pipe';

describe('MoviesDurationPipe', () => {
  it('create an instance', () => {
    const pipe = new MoviesDurationPipe();
    expect(pipe).toBeTruthy();
  });
});
