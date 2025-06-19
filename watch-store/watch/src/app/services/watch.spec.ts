import { TestBed } from '@angular/core/testing';

import { Watch } from './watch';

describe('Watch', () => {
  let service: Watch;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Watch);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
