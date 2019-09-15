import { Component, OnInit } from '@angular/core';
import { ContinentService } from '../continent.service';
import { CountryService } from '../country.service';
import { ActiviteService } from '../activite.service';
import { FormBuilder } from '@angular/forms';
import { HttpClient } from '@angular/common/http';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  

  items;
  searchForm;

  event;

  constructor(
    private continentservice : ContinentService, 
    private countryservice : CountryService, 
    private activiteservice : ActiviteService,
    private formBuilder: FormBuilder,
    private http : HttpClient) {

      this.searchForm = this.formBuilder.group({
        continent: '',
        pays: '',
        typacti: '',
        prix: '',
        temperature: '',
      });
     }

     onSubmit(searchData) {
      console.warn('Vous avez envoyé votre recherche', searchData);
      this.http.get('http://localhost:8000/city')
      .subscribe((data : any[]) => {
      this.cities = data;
      
      console.log (this.cityresult);
      
    });
  };

    continents = [];
  lespays = [];
  activites = [];
  cityresult=[];
  cities = [];
  ngOnInit() {

    this.continentservice.getContinents().subscribe((data : any[]) => {
      this.continents = data;
    });;

    this.countryservice.getPays().subscribe((data : any[]) => {
      this.lespays = data;
    });;

    this.activiteservice.getActivites().subscribe((data : any[]) => {
      this.activites = data;
    });;

    
  }
  
  

}
