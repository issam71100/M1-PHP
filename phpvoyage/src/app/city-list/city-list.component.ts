import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';


@Component({
  selector: 'app-city-list',
  templateUrl: './city-list.component.html',
  styleUrls: ['./city-list.component.css']
})

export class CityListComponent implements OnInit {
  
  constructor(private http : HttpClient) { }

  private cities = [];

  ngOnInit() {
    this.http.get('http://localhost:8000/city').subscribe((data : any[]) => {
      console.log(data);
      this.cities = data;
    });
  }
  


}
