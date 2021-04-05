import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'moviesDuration'
})
export class MoviesDurationPipe implements PipeTransform {

  transform(value: number, ...args: unknown[]): string {
    let minutes: number|string = Math.floor((value / 60) % 60);
    let hours: number|string = Math.floor((value / (60 * 60)) % 24);

    return hours + "h " + minutes + "m" 
  }

}
