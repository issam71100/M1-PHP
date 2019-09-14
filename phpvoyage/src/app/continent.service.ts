import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ContinentService {

  constructor(private http : HttpClient) { 

    
  }

  getContinents(){
  return this.http.get('http://localhost:8000/continent');
  }
}
