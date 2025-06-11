import { store } from "@wordpress/interactivity";

store("wp-modular", {
  state: {
    viewCount: "...",
  },
  actions: {
    views: {
      async init({ context, state }) {
        try {
          const res = await fetch(context.viewUrl);
          const json = await res.json();
          state.viewCount = json.views;
        } catch (err) {
          state.viewCount = "0";
        }
      },
    },
  },
});
