import Apps from '@components/Icons/Mono/Apps';
import Gear from '@components/Icons/Mono/Gear';
import Star from '@components/Icons/Star';
import Circles from '@components/Icons/Mono/Circles';
import Graph from '@components/Icons/Mono/Graph';
import Box from '@components/Icons/Box';
import AddGroup from '@components/Icons/AddGroup';
import Building from '@components/Icons/Building';
import Tax from '@components/Icons/Tax';
import Bag from '@components/Icons/ShoppingBag';
import Wallet from '@components/Icons/Wallet';
import Invoice from '@components/Icons/Invoice';
import CreditCard from '@components/Icons/CreditCard';
import Team from '@components/Icons/Team';
import Subfolder from '@components/Icons/Subfolder';
import EditProfile from '@components/Icons/EditProfile';
import Options from '@components/Icons/Options';
import Vibration from '@components/Icons/Vibration';
import Home from '@components/Icons/Mono/Home';
import Role from '@components/Icons/Role';
import Bill from '@components/Icons/Bill';
import SalesIncrease from '@components/Icons/SalesIncrease';
import CheckList from '@components/Icons/CheckList';

export const navLinks = [
  { text: 'Dashboard', icon: Home, to: '/dashboard', groups: [] },
  {
    text: 'Home',
    icon: Apps,
    groups: [
      {
        text: 'Workspace',
        children: [
          { text: 'Quotes', to: '/quotes', icon: Star },
          { text: 'Sales Order', to: '/orders', icon: Bag },
          { text: 'Invoices', to: '/invoices', icon: Invoice },
          { text: 'Payments', to: '/payments', icon: Wallet },
          { text: 'Expenses', to: '/expenses', icon: CreditCard }
        ]
      }
    ]
  },
  {
    text: 'References',
    icon: Circles,
    groups: [
      {
        text: 'Management',
        children: [
          { text: 'Products', to: '/products', icon: Box },
          { text: 'Customers', to: '/customers', icon: AddGroup },
          { text: 'Categories', to: '/categories', icon: Subfolder },
          { text: 'Unit', to: '/unit', icon: CheckList }
        ]
      }
    ]
  },
  {
    text: 'Reports',
    icon: Graph,
    groups: [
      {
        text: 'Reports',
        children: [
          { text: 'Sales Report', to: '/sales-report', icon: SalesIncrease }
        ]
      }
    ]
  },
  {
    text: 'Settings',
    icon: Gear,
    groups: [
      {
        text: 'Settings',
        children: [
          { text: 'Company', to: '/company', icon: Building },
          { text: 'Account', to: '/account', icon: EditProfile },
          { text: 'Preferences', to: '/preferences', icon: Options },
          { text: 'Members', to: '/members', icon: Team },
          { text: 'Roles', to: '/roles', icon: Role },
          { text: 'Billing', to: '/billing', icon: Bill },
          { text: 'Payment Terms', to: '/payment-terms', icon: CreditCard },
          { text: 'Payment Modes', to: '/payment-modes', icon: Vibration },
          { text: 'Tax', to: '/tax', icon: Tax }
        ]
      }
    ]
  }
];
