import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ActiviteService {

  constructor(private http : HttpClient) { 

    
  }

  getActivites(){
  return this.http.get('http://localhost:8000/activity');
  }
}