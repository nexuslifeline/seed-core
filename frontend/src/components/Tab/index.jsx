import { Tab } from '@headlessui/react';
import PropTypes from 'prop-types';
import Styles from './Tab.module.scss';
import classNames from 'classnames';

const Panel = ({ children, panelItemClass, ...props }) => {
  return (
    <Tab.Panel className={classNames(Styles.panelItem, panelItemClass)} {...props}>
      {children}
    </Tab.Panel>
  );
};

const BaseTab = ({ children, className, tabListClass, panelsClass, ...props }) => {
  return (
    <Tab.Group className={className} {...props}>
      {children.length > 0 && (
        <Tab.List className={classNames(Styles.tabList, tabListClass)}>
          {children.map((item, idx) => {
            const { title, listItemClass } = item.props;
            return (
              <Tab key={idx} className={classNames(Styles.listItem, listItemClass)}>
                {title}
              </Tab>
            );
          })}
        </Tab.List>
      )}
      <Tab.Panels className={panelsClass}>{children || ''}</Tab.Panels>
    </Tab.Group>
  );
};

BaseTab.Panel = Panel;

BaseTab.propTypes = {
  items: PropTypes.array,
  children: PropTypes.node,
};

export default BaseTab;
