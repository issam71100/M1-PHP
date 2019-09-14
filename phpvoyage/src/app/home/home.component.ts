import { Component, OnInit } from '@angular/core';
import { ContinentService } from '../continent.service';
import { CountryService } from '../country.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(private continentservice : ContinentService, private countryservice : CountryService) { }

  private continents = [];
  private lespays = [];

  ngOnInit() {

    this.continentservice.getContinents().subscribe((data : any[]) => {
      console.log(data);
      this.continents = data;
    });;

    this.countryservice.getPays().subscribe((data : any[]) => {
      console.log(data);
      this.lespays = data;
    });;
  }

}
