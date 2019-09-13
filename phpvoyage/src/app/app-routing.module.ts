import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {CityListComponent} from "./city-list/city-list.component";
import {HomeComponent} from "./home/home.component";


const routes: Routes = [
  { path: 'home', component: HomeComponent},
  { path: 'cities', component: CityListComponent},
  { path: '',
    redirectTo: '/home',
    pathMatch: 'full'
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
