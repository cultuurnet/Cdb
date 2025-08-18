## 2.1.0

Changes from 2.0.2

- Implement additions in cdbxml schema version 3.3
- Keywords are now represented as CultureFeed_Cdb_Data_Keyword objects, although
  discouraged strings can be still used for backwards compatibility reasons
- Add cdb scheme version parameter to CultureFeed_Cdb_Default constructor,
  CultureFeed_Cdb_Item_Event::appendToDOM() etc. to allow different versions of 
  cdb xml to be produced
- Deprecated CultureFeed_Cdb_Default::CDB_SCHEME_URL in favor of 
  CultureFeed_Cdb_Xml::namespaceUriForVersion()
- Add new media type _collaboration_
