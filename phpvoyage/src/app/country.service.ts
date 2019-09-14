import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class CountryService {

  constructor(private http : HttpClient) { 

    
  }

  getPays(){
  return this.http.get('http://localhost:8000/country');
  }
}

