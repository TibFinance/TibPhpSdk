<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      font-family: sans-serif;
    }

    .li-group {
      margin-top: 5px;
    }

      .li-group strong {
        margin-bottom: 0px;
      }
  </style>
  <title>Tib Portal Test.</title>
</head>

<body>
  <h1> Tib Portal Call List </h1>
  <ul>
    <li class="li-group">
      <strong>Login (Create Session)</strong>
      <form action="./Calls.php?action=CreateSession" method="POST">
        <!-- <input type="text" placeholder="Client ID" name="clientId">
        <input type="text" placeholder="Username" name="username">
        <input type="password" placeholder="Password" name="password"> -->
        <input type="submit" value="Login">
      </form>
    </li>
    <li class="li-group">
      <strong>Customers</strong>
      <ul>
        <li><a href="./Calls.php?action=CreateCustomer" targer="_blank">Create a customer</a></li>
        <li><a href="./Calls.php?action=ListCustomers" targer="_blank">List All service customers</a></li>
        <li><a href="./Calls.php?action=GetCustomer" targer="_blank">get a customer details </a></li>
        <li>
          <a href="./Calls.php?action=GetCustomersByExternalId" targer="_blank">
            List the Customers based on external
            Identification
          </a>
        </li>
        <li><a href="./Calls.php?action=SaveCustomer" targer="_blank">Modify an existing customer</a></li>
        <li><a href="./Calls.php?action=DeleteCustomer" targer="_blank">Delete a customer</a></li>
      </ul>
    </li>
    <li class="li-group">
      <strong>PaymentMethods</strong>
      <ul>
        <li>
          <a href="./Calls.php?action=CreateDirectAccountPaymentMethod" targer="_blank">
            Create bank account payment
            method.
          </a>
        </li>
        <li>
          <a href="./Calls.php?action=CreateCreditCardPaymentMethod" targer="_blank">
            Create credit card payment method
          </a>
        </li>
        <li>
          <a href="./Calls.php?action=CreateInteracPaymentMethod" targer="_blank">Create Interac payment method.</a>
        </li>
        <li>
          <a href="./Calls.php?action=ChangeInteracPaymentMethodQuestionAndAnswer" targer="_blank">
            Change Interac
            Payment Method Question
            and Answer
          </a>
        </li>
        <li><a href="./Calls.php?action=getPaymentMethod" targer="_blank">Get a specific payment method</a></li>
        <li><a href="./Calls.php?action=ListPaymentMethods" targer="_blank">List payment methods</a></li>
        <li>
          <a href="./Calls.php?action=SetDefaultPaymentMethod" targer="_blank">
            Change the default payment method of
            a customer.
          </a>
        </li>
        <li><a href="./Calls.php?action=DeletePaymentMethod" targer="_blank">Delete payment method.</a></li>
      </ul>
    </li>
    <li class="li-group">
      <strong>Payments / Transfers</strong>
      <ul>
        <li><a href="./Calls.php?action=CreateBill" targer="_blank">Create Bill</a></li>
        <li><a href="./Calls.php?action=ListBills" targer="_blank">List Bill</a></li>
        <li><a href="./Calls.php?action=GetBill" targer="_blank">Get Bill</a></li>
        <li><a href="./Calls.php?action=DeleteBill" targer="_blank">Delete Bill</a></li>
        <li><a href="./Calls.php?action=CreatePayement" targer="_blank">Create payment</a></li>
        <li><a href="./Calls.php?action=CreateDirectDeposit" targer="_blank">Create Direct Deposit</a></li>
        <li>
          <a href="./Calls.php?action=CreateDirectInteracTransaction" targer="_blank">Create Interac Transfer</a>
        </li>
        <li><a href="./Calls.php?action=CreateTransactionFromRaw" targer="_blank">Create From ACP File</a></li>
        <li><a href="./Calls.php?action=CreateFreeOperation" targer="_blank">Create Free operation</a></li>
        <li><a href="./Calls.php?action=DeletePayement" targer="_blank">Delete Transfer</a></li>
        <li><a href="./Calls.php?action=RevertTransfer" targer="_blank">Revert Transfer</a></li>
        <li><a href="./Calls.php?action=GetRecuringTransfers" targer="_blank">List Recuring</a></li>
        <li><a href="./Calls.php?action=DeleteRecuringTransfer" targer="_blank">Delete Recutin proccess</a></li>
      </ul>
    </li>
    <li class="li-group">
      <strong>Whitelabelings</strong>
      <ul>
        <li><a href="./Calls.php?action=SetWhiteLabeling" targer="_blank">Set WhiteLabeling</a></li>
        <li><a href="./Calls.php?action=GetWhiteLabeling" targer="_blank">Get WhiteLabeling</a></li>
        <li><a href="./Calls.php?action=UpdateWhiteLabeling" targer="_blank">updateWhiteLabeling</a></li>
        <li><a href="./Calls.php?action=DeleteWhiteLabeling" targer="_blank">Delete Whitelabeling</a></li>
        <li><a href="./Calls.php?action=GetListWhiteLabeling" targer="_blank">Get List WhiteLabeling</a></li>
      </ul>
    </li>
    <li class="li-group">
      <strong>Reporting of operations</strong>
      <ul>
        <li><a href="./Calls.php?action=ListExecutedOperations" targer="_blank">List Executed Operations</a></li>
      </ul>
    </li>
    <li class="li-group">
      <strong>Clients</strong>
      <ul>
        <li><a href="./Calls.php?action=CreateSubClient" targer="_blank">Create Sub client </a></li>
        <li>
          <a href="./Calls.php?action=SetClientDefaultServicefeeSettings" targer="_blank">
            set client default service
            fee settings
          </a>
        </li>
        <li><a href="./Calls.php?action=SetClientSettings" targer="_blank">set client settings</a></li>
        <li><a href="./Calls.php?action=GetClientSettings" targer="_blank">Get client settings</a></li>
      </ul>
    </li>
  </ul>

</body>

</html>