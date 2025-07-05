import React from 'react';
import { Disclosure, Transition } from '@headlessui/react';
import ChevronDown from '@components/Icons/ChevronDown';
import ChevronUp from '@components/Icons/ChevronUp';
import Styles from './Accordion.module.scss';

const Accordion = ({ items, ...props }) => {
  return (
    <>
      {items.map(({ header, content }, index) => (
        <Disclosure className={Styles.container} {...props} key={index} as='div'>
          {({ open }) => (
            <>
              <Disclosure.Button className={Styles.header}>
                {header}
                {(open && <ChevronUp className={Styles.icon} />) || <ChevronDown className={Styles.icon} />}
              </Disclosure.Button>
              <Transition
                enter={Styles.transitionEnter}
                enterFrom={Styles.enterFrom}
                enterTo={Styles.enterTo}
                leave={Styles.transitionLeave}
                leaveFrom={Styles.leaveFrom}
                leaveTo={Styles.leaveTo}>
                <Disclosure.Panel className={Styles.panel}>{content}</Disclosure.Panel>
              </Transition>
            </>
          )}
        </Disclosure>
      ))}
    </>
  );
};

export default Accordion;
