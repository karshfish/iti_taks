
import { SavingAccount } from './SavingAccount.js';
import { CurrentAccount } from './CurrentAccount.js';

// Create SavingAccount
const sa = new SavingAccount(1001, 5000, new Date('2023-01-01'), 1000);
sa.addCustomer('Alice');
console.log('Saving initial balance:', sa.getBalance());
console.log('Try debit 4500 (should fail due to min balance):', sa.debitAmount(4500));
console.log('Balance after failed debit:', sa.getBalance());
console.log('Try debit 3000 (should succeed):', sa.debitAmount(3000));
console.log('Balance after debit:', sa.getBalance());

// Create CurrentAccount
const ca = new CurrentAccount(2001, 10000, new Date('2024-06-01'), 5.5);
ca.addCustomer('Bob');
console.log('Current initial balance:', ca.getBalance());
ca.creditAmount(500);
console.log('After credit 500:', ca.getBalance());
ca.applyInterest();
console.log('After applying interest:', ca.getBalance());
