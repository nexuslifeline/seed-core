import Styles from './Breadcrumb.module.scss';
import Text from '@components/Text';
import classNames from 'classnames';
import { Link } from 'react-router-dom';

const Breadcrumb = ({ title, items }) => {
  return (
    <div className={Styles.container}>
      {title && (
        <Text variant='title' size='xl'>
          {title}
        </Text>
      )}
      <ul className={classNames(Styles.items, { [Styles.border]: !!title })}>
        {items.map(({ text, to }, idx) => (
          <li key={idx} className={Styles.item}>
            {to ? <Link to={to}>{text}</Link> : text}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Breadcrumb;
