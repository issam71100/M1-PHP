import { TestBed } from '@angular/core/testing';

import { ContinentService } from './continent.service';

describe('ContinentService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ContinentService = TestBed.get(ContinentService);
    expect(service).toBeTruthy();
  });
});
