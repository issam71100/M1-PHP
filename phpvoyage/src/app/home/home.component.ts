import { Component, OnInit } from '@angular/core';
import { ContinentService } from '../continent.service';
import { CountryService } from '../country.service';
import { ActiviteService } from '../activite.service';
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(private router: Router, private formBuilder: FormBuilder, private continentservice: ContinentService, private countryservice: CountryService, private activiteservice : ActiviteService) { }

  private tripForm: FormGroup;
  private continents = [];
  private lespays = [];
  private activites = [];
  event;

  ngOnInit() {

    this.continentservice.getContinents().subscribe((data : any[]) => {
      console.log(data);
      this.continents = data;
    });

    this.countryservice.getPays().subscribe((data : any[]) => {
      console.log(data);
      this.lespays = data;
    });

    this.activiteservice.getActivites().subscribe((data : any[]) => {
      console.log(data);
      this.activites = data;
    });

    this.initForm();
  }

  initForm(){
    this.tripForm = this.formBuilder.group({
      continent: ['', Validators.required],
      pays: ['', Validators.required],
      resulttemp: ['', Validators.required],
      resultprix: ['', Validators.required],
      typacti: ['', Validators.required]
    });
    console.log("url init " + this.router.url);
  }

  onSubmit(event){
    //console.log(event);
    const continent = this.tripForm.get('continent').value;
    const pays = this.tripForm.get('pays').value;
    const temp = this.tripForm.get('resulttemp').value;
    const prix = this.tripForm.get('resultprix').value;
    const typacti = this.tripForm.get('typacti').value;
    console.log("url submit " + this.router.url);

    console.log("continent "+continent); // ne s'affiche pas
    console.log("pays "+pays); // fonctionne
    console.log("temperature" +temp); // ne s'affiche pas
    console.log("prix "+prix); // ne s'affiche pas
    console.log("type acti "+typacti); // affiche true

    //this.router.navigate(['/cities']);
    /**
     * SELECT * FROM City ci, Activity a, Country cou, Continent Con, Month m
     * WHERE Ci.country_id = cou.id
     * AND cou.continent_id = con.id
     * AND a.city_id = ci.id
     * AND m.activity_id = a.id
     * AND con.name = continent
     * AND cou.name = pays
     * AND m.temperature = temp
     * AND a.price = prix
     * AND a.type = typacti;
     */
  }

}
