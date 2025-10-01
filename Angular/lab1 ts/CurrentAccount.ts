
import { Account } from './Account.js';

export class CurrentAccount extends Account {
  public interestRate: number; 

  constructor(accNo: number, balance: number, dateOfOpening: Date, interestRate: number) {
    super(accNo, balance, dateOfOpening);
    this.interestRate = interestRate;
  }

  // optional helper to apply interest (not required by UML but useful)
  public applyInterest(): void {
    const interest = (this.balance * this.interestRate) / 100;
    this.creditAmount(interest);
  }
}
