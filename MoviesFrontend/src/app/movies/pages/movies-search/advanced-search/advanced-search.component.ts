import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'advanced-search',
  templateUrl: './advanced-search.component.html',
  styleUrls: ['./advanced-search.component.scss']
})
export class AdvancedSearchComponent implements OnInit {

  genres: Array<any> = [
    { name: 'Action', value: 'Action', isSelected: false },
    { name: 'Adventure', value: 'Adventure', isSelected: false  },
    { name: 'Animation', value: 'Animation', isSelected: false  },
    { name: 'Biography', value: 'Biography', isSelected: false  },
    { name: 'Comedy', value: 'Comedy', isSelected: false  },
    { name: 'Crime', value: 'Crime', isSelected: false  },
    { name: 'Documentary', value: 'Documentary', isSelected: false  },
    { name: 'Drama', value: 'Drama', isSelected: false  },
    { name: 'Family', value: 'Family', isSelected: false  },
    { name: 'Experimental', value: 'Experimental', isSelected: false  },
    { name: 'Fantasy', value: 'Fantasy', isSelected: false  },
    { name: 'History', value: 'History', isSelected: false  },
    { name: 'Horror', value: 'Horror', isSelected: false  },
    { name: 'Music', value: 'Music', isSelected: false  },
    { name: 'Musical', value: 'Musical', isSelected: false  },
    { name: 'Mystery', value: 'Mystery', isSelected: false  },
    { name: 'Sci-Fi', value: 'Sci-Fi', isSelected: false  },
    { name: 'Sport', value: 'Sport', isSelected: false  },
    { name: 'Superhero', value: 'Superhero', isSelected: false  },
    { name: 'Thriller', value: 'Thriller', isSelected: false  },
    { name: 'War', value: 'War', isSelected: false  },
    { name: 'Western', value: 'Western', isSelected: false  }
  ];
  form: FormGroup;

  constructor(private formBuilder: FormBuilder, private route: ActivatedRoute, private router: Router) {
    this.form = this.formBuilder.group({
      title: ""
    })
  }

  onCheckboxChange(checkbox) {
    const genreChange=this.genres.find(({name})=>name===checkbox.target.value);
    genreChange.isSelected=checkbox.target.checked;
  }

  onAdvancedSearch() {
    const genresSelected = this.genres.reduce((accum, genre)=>{
      if(genre.isSelected){
        accum.push(genre.name);
      }
      return accum;
    },[]);

    let queryParams = {...this.form.value, page : 1}

    if(genresSelected.length > 0){
      queryParams = {...queryParams, 'genres[]': genresSelected}
    }

    this.router.navigate(['/search'], {queryParams:queryParams}); 
  }

  ngOnInit(): void {
    this.route.queryParamMap.subscribe(params => {
      this.genres = this.genres.map((genre)=> {
        if(params.getAll('genres[]').includes(genre.name)){
          genre.isSelected = true;
        }
        return genre;
      })
    }
    )
  }


}
