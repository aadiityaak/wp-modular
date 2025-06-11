import { store } from "@wordpress/interactivity";

store("wp-modular", {
  state: {
    viewCount: "...",
  },
  actions: {
    views: {
      async init({ context, state }) {
        try {
          // 1. Ambil jumlah views
          const res = await fetch(context.viewUrl);
          const json = await res.json();
          state.viewCount = json.views;

          // 2. Tambahkan 1 view (POST)
          await fetch(context.viewUrl, {
            method: "POST",
          });

          // 3. Ambil lagi jumlah view terbaru
          const updated = await fetch(context.viewUrl);
          const updatedJson = await updated.json();
          state.viewCount = updatedJson.views;
        } catch (err) {
          console.error("Error fetching views:", err);
        }
      },
    },
  },
});
