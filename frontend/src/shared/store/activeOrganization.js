import { create } from 'zustand';

export const useActiveOrganization = create((set) => ({
  activeOrganization: null,
  setActiveOrganization: (data) => set({ activeOrganization: data })
}));
