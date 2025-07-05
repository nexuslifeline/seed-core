import { Fragment } from 'react';
import Menu from '@components/Menu';
import Styles from './Dropdown.module.scss';

const Dropdown = ({ children, button, direction, items }) => {
  return (
    <Menu>
      <Menu.Button as={Fragment}>{button || children}</Menu.Button>
      <Menu.Items direction={direction} className={Styles.items}>
        <ul>
          {items.map((item) => (
            <Menu.Item as='li'>
              <span>{item?.text}</span>
            </Menu.Item>
          ))}
        </ul>
      </Menu.Items>
    </Menu>
  );
};

export default Dropdown;
