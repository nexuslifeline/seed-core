import PropTypes from 'prop-types';
import Styles from './Card.module.scss';

const Card = ({ body, header, footer, children, ...props }) => {
  const run = (cb) => (typeof cb === 'function' ? cb() : cb);
  return (
    <div className={Styles.container} style={{ ...props }}>
      {header && <div className={Styles.header}>{run(header)}</div>}

      <div className={Styles.body}>
        {run(body)}
        {children}
      </div>
      {footer && <div className={Styles.footer}>{run(footer)}</div>}
    </div>
  );
};

Card.propTypes = {
  children: PropTypes.node,
  body: PropTypes.oneOfType([PropTypes.string, PropTypes.func]),
  header: PropTypes.oneOfType([PropTypes.string, PropTypes.func]),
  footer: PropTypes.oneOfType([PropTypes.string, PropTypes.func]),
};

export default Card;
