import { Component, OnInit } from '@angular/core';
import { ContinentService } from '../continent.service';
import { CountryService } from '../country.service';
import { ActiviteService } from '../activite.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(private continentservice : ContinentService, private countryservice : CountryService, private activiteservice : ActiviteService) { }

  private continents = [];
  private lespays = [];
  private activites = [];

  ngOnInit() {

    this.continentservice.getContinents().subscribe((data : any[]) => {
      console.log(data);
      this.continents = data;
    });;

    this.countryservice.getPays().subscribe((data : any[]) => {
      console.log(data);
      this.lespays = data;
    });;

    this.activiteservice.getActivites().subscribe((data : any[]) => {
      console.log(data);
      this.activites = data;
    });;
  }

}
