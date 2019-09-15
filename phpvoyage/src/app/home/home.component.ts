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
  }

  onSubmit(event){
    //console.log(event);
    const continent = this.tripForm.get('continent').value;
    const pays = this.tripForm.get('pays').value;
    const barretemp = this.tripForm.get('resulttemp').value;
    const barreprix = this.tripForm.get('resultprix').value;
    const typacti = this.tripForm.get('typacti').value;

    this.router.navigate(['/cities']);
  }

}
