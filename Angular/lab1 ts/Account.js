export class Account {
    constructor(accNo, balance, dateOfOpening) {
        this.customers = [];
        this.accNo = accNo;
        this.balance = balance;
        this.dateOfOpening = dateOfOpening;
    }
    // IAccount methods
    addCustomer(customerName) {
        if (this.customers.indexOf(customerName) === -1) {
            this.customers.push(customerName);
        }
    }
    removeCustomer(customerName) {
        this.customers = this.customers.filter(c => c !== customerName);
    }
    // Account operations
    /**
     * Debit amount from account.
     * Returns true if successful, false if insufficient funds (or subclass rules).
     */
    debitAmount(amount) {
        if (amount <= 0)
            return false;
        if (amount <= this.balance) {
            this.balance -= amount;
            return true;
        }
        return false;
    }
    creditAmount(amount) {
        if (amount > 0) {
            this.balance += amount;
        }
    }
    getBalance() {
        return this.balance;
    }
}
