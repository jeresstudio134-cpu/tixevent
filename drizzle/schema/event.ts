import {
  pgTable,
  uuid,
  varchar,
} from "drizzle-orm/pg-core";

export const events = pgTable("events", {

  id: uuid("id").defaultRandom().primaryKey(),

  title: varchar("title",{length:255}).notNull(),

});