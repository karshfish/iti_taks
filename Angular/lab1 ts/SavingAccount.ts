// src/models/SavingAccount.ts
import { Account } from './Account.js';

export class SavingAccount extends Account {
  public minBalance: number;

  constructor(accNo: number, balance: number, dateOfOpening: Date, minBalance: number) {
    super(accNo, balance, dateOfOpening);
    this.minBalance = minBalance;
  }

  // override debit to enforce min balance
  public debitAmount(amount: number): boolean {
    if (amount <= 0) return false;
    const projected = this.getBalance() - amount;
    if (projected < this.minBalance) {
      // would violate min balance
      return false;
    }
    return super.debitAmount(amount);
  }
}
