import Styles from './SubPanelSection.module.scss';
import { useLocation, Link } from 'react-router-dom';
import classNames from 'classnames';

const SubPanelSection = ({ title, children, links }) => {
  const location = useLocation();

  return (
    <div className={Styles.container}>
      <div className={Styles.title}>
        {title}
        {/* <button className={Styles.btnSearch}>
          <MagnifyingGlass />
        </button> */}
      </div>
      {children}
      <ul className={Styles.menus}>
        {links.map(({ icon: Icon, text, to }, idx) => {
          return (
            <li key={idx} className={classNames(Styles.menu, to === location?.pathname && Styles.active)}>
              <Link to={to} className={Styles.link}>
                <Icon className={Styles.icon} />
                {text}
              </Link>
            </li>
          );
        })}
        {/* <li className={classNames(Styles.menu, Styles.active)}>
          <Star className={Styles.icon} />
          {'Invoices'}
        </li>
        <li className={Styles.menu}>
          <Bookmark className={Styles.icon} />
          {'Recurring Invoices'}
        </li>
        <li className={Styles.menu}>
          <Cash className={Styles.icon} />
          {'Payments'}
        </li>
        <li className={Styles.menu}>
          <Card className={Styles.icon} />
          {'Expenses'}
        </li> */}
      </ul>
    </div>
  );
};

export default SubPanelSection;
