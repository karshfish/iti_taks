import { Account } from './Account.js';
export class CurrentAccount extends Account {
    constructor(accNo, balance, dateOfOpening, interestRate) {
        super(accNo, balance, dateOfOpening);
        this.interestRate = interestRate;
    }
    // optional helper to apply interest (not required by UML but useful)
    applyInterest() {
        const interest = (this.balance * this.interestRate) / 100;
        this.creditAmount(interest);
    }
}
