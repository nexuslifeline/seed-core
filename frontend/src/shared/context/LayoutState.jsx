import { createContext } from 'react';

export const LayoutStateContext = createContext();

export const withLayoutState = (Component) => {
  return function WrapperComponent(props) {
    return <LayoutStateContext.Consumer>{(state) => <Component {...props} {...state} />}</LayoutStateContext.Consumer>;
  };
};
